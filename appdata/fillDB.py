#!/usr/bin/env python3

import mysql.connector as sql
import os

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
path = BASE_DIR + "/hangmanWords.txt"

with open(path, 'r') as f:
    words = f.readlines()

words = [w.strip() for w in words]

con = sql.connect(host="localhost", username="root", password="", database="games")
cursor = con.cursor()

for word in words:
    cursor.execute(f"INSERT hangman VALUES(NULL, '{word}')")

con.close()

