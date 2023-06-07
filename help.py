from flask import Flask, render_template, request, redirect, url_for
from flask_login import LoginManager, UserMixin, login_required, login_user, logout_user
import pandas as pd
import time
import matplotlib.pyplot as plt
import io
import base64

app = Flask(__name__)
app.secret_key = 'secret-key' # Change this to a more secure key in production
login_manager = LoginManager()
login_manager.init_app(app)

# Mock user database
class User(UserMixin):
    def __init__(self, username, password):
        self.id = username
        self.password = password

users = {
    'user1': User('user1', 'password1'),
    'user2': User('user2', 'password2'),
}

# User loader function
@login_manager.user_loader
def load_user(user_id):
    return users.get(user_id)

# Login page
@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        if username in users and password == users[username].password:
            user = users[username]
            login_user(user)
            return redirect(url_for('plot'))
        else:
            return "Invalid login"
    else:
        return '''
               <form method="post">
                <p><input type=text name=username>
                <p><input type=password name=password>
                <p><input type=submit value=Login>
               </form>
               '''

# Logout page
@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('login'))

# Plot page
@app.route('/plot')
@login_required
def plot():
    # Read data from CSV file
    data = pd.read_csv('data1.csv')

    # Plot data and encode it as base64 for display in HTML
    buf = io.BytesIO()
    plt.plot(data['date'], data['value'])
    plt.title('My Plot')
    plt.xlabel('Date')
    plt.ylabel('Value')
    plt.savefig(buf, format='png')
    buf.seek(0)
    plot_url = base64.b64encode(buf.getvalue()).decode()

    # Render HTML template with plot
    return render_template('plot.html', plot_url=plot_url)


if __name__ == '__main__':
    app.run(host='0.0.0.0',debug=True, port="8090")


