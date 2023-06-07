#!/bin/bash
for i in `cat both.txt`; do docker stop $i; done
