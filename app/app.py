
import dash
import dash_auth
from dash import dcc
from dash import html
from dash.dependencies import Input, Output, State
from dash.exceptions import PreventUpdate

import pandas as pd
import plotly.graph_objs as go
from datetime import datetime
import time
import pytz
import numpy as np
import os
import plotly.express as px
from flask_caching import Cache
from flask_login import LoginManager, UserMixin, login_user

# Retrieve values from environment variables or use default values
csv_filename_local = os.environ.get('CSV_FILENAME_LOCAL', 'default.csv')
csv_filename_cryo = os.environ.get('CSV_FILENAME_CRYO', 'default.csv')

app_title = os.environ.get('APP_TITLE', 'My Dash App')
header_text = os.environ.get('HEADER_TEXT', 'My Dashboard')
ref_val_1 = os.environ.get('REF_VAL_1', 'default_ref_val_1')
ref_val_2 = os.environ.get('REF_VAL_2', 'default_ref_val_2')
port = int(os.environ.get('PORT', 8090))
USERNAME = os.environ.get('DASH_USERNAME')
PASSWORD = os.environ.get('DASH_PASSWORD')
admin_username = 'root'
admin_password = 'Str..Biol'

# Define your username and password
VALID_USERNAME_PASSWORD_PAIRS = [(USERNAME, PASSWORD), (admin_username,admin_password)]

# Define the layout of the app
app = dash.Dash(__name__,  title=app_title)
#cache = Cache(app.server, config={ 'CACHE_TYPE': 'simple'})

# Set up Flask-Login
# ~ server = app.server
# ~ login_manager = LoginManager()
# ~ login_manager.init_app(server)


# ~ # Define User class for Flask-Login
# ~ class User(UserMixin):
    # ~ def __init__(self, username):
        # ~ self.id = username


# ~ # Callback to validate the username and password
# ~ @login_manager.request_loader
# ~ def load_user_from_request(request):
    # ~ username = request.form.get('username')
    # ~ password = request.form.get('password')
    # ~ if (username, password) in VALID_USERNAME_PASSWORD_PAIRS:
        # ~ user = User(username)
        # ~ login_user(user)
        # ~ return user


# Enable session-based authentication
#auth = dash_auth.SessionAuth( app, VALID_USERNAME_PASSWORD_PAIRS, cache=cache )
auth = dash_auth.BasicAuth( app, VALID_USERNAME_PASSWORD_PAIRS)

# Load your data files
data1 = pd.read_csv(csv_filename_local)
data2 = pd.read_csv(csv_filename_cryo)


app.layout = html.Div([
    html.H1(header_text),
    html.Button('Toggle Axis Scale', id='toggle-axis-button', n_clicks=0),
    html.Div(id='date'),
    html.Div([
        dcc.Graph(id='plot1a', style={'width': '100%', 'height': '100%', 'display': 'inline-block'}),
        html.P("Explanation for Plot 1"),
        html.P("Explanation for Plot 1- line2 "),
    ], style={'width': '50%', 'display': 'inline-block'}),
    html.Div([
        dcc.Graph(id='plot2a', style={'width': '100%', 'height': '100%', 'display': 'inline-block'}),
        html.P("Explanation for Plot 2"), 
        html.P("Explanation for plot 2 - line 2"),
    ], style={'width': '50%', 'display': 'inline-block'}),
    dcc.Interval(
        id='interval-component',
        interval=300*1000,  # in milliseconds
        n_intervals=0
    )
], style={'margin': '2%'})


# Define the callbacks to update the graphs and date
@app.callback([Output('plot1a', 'figure'), 
               Output('plot2a', 'figure') ], 
               [Input('toggle-axis-button', 'n_clicks'), Input('interval-component', 'n_intervals')],     
               [State('plot1a', 'figure'), State('plot2a', 'figure')]
)
def update_plots(n_clicks,n, fig1a, fig2a):
	
    ctx = dash.callback_context
    trigger_id = ctx.triggered[0]['prop_id'].split('.')[0]
    new_type = 'linear'
    if trigger_id == 'toggle-axis-button':
        if n_clicks % 2 == 0:
            new_type = 'linear'
        else:
            new_type = 'log'
            
        #fig1a['layout']['yaxis']['type'] = new_type
        #fig2a['layout']['yaxis']['type'] = new_type
	
    csv_filename_local = os.environ.get('CSV_FILENAME_LOCAL', 'default.csv')
    csv_filename_cryo = os.environ.get('CSV_FILENAME_CRYO', 'default.csv')
    # Reload the data files every 10 seconds
    data1 = pd.read_csv(csv_filename_local)
    data2 = pd.read_csv(csv_filename_cryo)
    print(len(data1['date']))
    print(len(data2['date']))
    # Merge based on data tag
    merged_data = pd.merge(data1, data2, on='date', how='inner')
    # Calculate the ratio and the average
    merged_data['ratio_GB'] = merged_data['GB_x'] / merged_data['GB_y']
    merged_data['ratio_n'] = merged_data['nfiles_x'] / merged_data['nfiles_y']
    merged_data['aver_GB'] = (merged_data['GB_x']  + merged_data['GB_y']) / 2.0
    merged_data['aver_n'] = ( merged_data['nfiles_x'] + merged_data['nfiles_y'] ) / 2.0
    merged_data['date'] = pd.to_datetime(merged_data['date'])
    
    # Check lengths of columns
    #print(merged_data)
    #print(len(merged_data['date']))
    #print(len(merged_data['ratio_GB']))
    
    # Do some math with the data structures, store the results in data3
    # ~ data3 = pd.DataFrame({'date': data1['date']})
    # ~ data3['ratio_gb'] = np.where(data2['GB'] != 0, data1['GB'] / data2['GB'], None)
    # ~ data3['ratio_nfiles'] = np.where(data2['nfiles'] != 0, data1['nfiles'] / data2['nfiles'], None)
    # ~ # Drop rows with NaN values, if desired
    # ~ data3 = data3.dropna()
    # ~ print(data3)

    #data1['ratio_gb'] = data1['GB'] / data2['GB']
    #data1['ratio_nfiles'] = data1['nfiles'] / data2['nfiles']
    
    fig1a = go.Figure(
        data=[go.Scatter(x=data1['date'], y=data1['GB'], name='storage_local', yaxis='y1', mode='markers+lines', 
              hovertemplate='Date: %{x}<br>LOCAL: %{y:.2f} GB<br>CRYO: %{customdata:.2f} GB<extra></extra>', customdata=data2['GB']),
              go.Scatter(x=data2['date'], y=data2['GB'], name='storage_cryo' , yaxis='y2', mode='markers+lines', 
              hovertemplate='Date: %{x}<br>LOCAL: %{customdata:.2f} GB<br>CRYO: %{y:.2f} GB<extra></extra>', customdata=data1['GB']) ],
        layout=go.Layout(title='Storage vs Time',  
                         yaxis=dict(title='Storage LOCAL (GB)', side='left',  type=new_type), 
                         yaxis2=dict(title='Storage CRYO (GB)', side='right', overlaying='y', showgrid=False,  type=new_type),)
    )
    fig2a = go.Figure(
        data=[go.Scatter(x=data1['date'], y=data1['nfiles'], name='inodes_local', yaxis='y1', mode='markers+lines', 
              hovertemplate='Date: %{x}<br>LOCAL: %{y:.2f}<br>Inodes CRYO: %{customdata:.2f}<extra></extra>', customdata=data2['nfiles']),
              go.Scatter(x=data2['date'], y=data2['nfiles'] , name='inodes_cryo', yaxis='y2', mode='markers+lines',  
              hovertemplate='Date: %{x}<br>Inodes LOCAL: %{customdata:.2f}<br>Inodes CRYO: %{y:.2f}<extra></extra>', customdata=data1['nfiles']) ],
        layout=go.Layout(title='Inode vs Time',  yaxis=dict(title='# files (inodes) LOCAL', side='left',  type=new_type),
                                                 yaxis2=dict(title='# files (inodes) CRYO', side='right', overlaying='y', showgrid=False,  type=new_type),)
    )
        
    return fig1a, fig2a


@app.callback(Output('date', 'children'), [Input('interval-component', 'n_intervals')])
def update_date(n):
	# Print current date and time
    now = datetime.now(pytz.timezone('Europe/Berlin')).strftime("%m/%d/%Y %H:%M:%S")
    return  f"Last updated: {now}"

if __name__ == '__main__':
    app.run_server(host='0.0.0.0',debug=True, port=port)


