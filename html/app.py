from flask import Flask, render_template, request, redirect, url_for, flash

app = Flask(__name__)
app.secret_key = 'supersecretkey'

# Simulierte Datenbank (In der Realität wäre dies eine echte Datenbank)
users = {}

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/create_user', methods=['POST'])
def create_user():
    first_name = request.form['first_name']
    last_name = request.form['last_name']
    password = request.form['password']
    principal_id = request.form['principal_id']

    # Hier würden Sie den Benutzer in einem echten System erstellen
    if principal_id in users:
        flash('Benutzer existiert bereits!')
    else:
        users[principal_id] = {'first_name': first_name, 'last_name': last_name, 'password': password}
        flash('Benutzer erfolgreich erstellt!')

    return redirect(url_for('index'))

@app.route('/change_password', methods=['POST'])
def change_password():
    principal_id = request.form['principal_id']
    new_password = request.form['new_password']

    # Passwortänderung im echten System
    if principal_id in users:
        users[principal_id]['password'] = new_password
        flash('Passwort erfolgreich geändert!')
    else:
        flash('Benutzer nicht gefunden!')

    return redirect(url_for('index'))

@app.route('/delete_user', methods=['POST'])
def delete_user():
    principal_id = request.form['principal_id']

    # Benutzer löschen im echten System
    if principal_id in users:
        del users[principal_id]
        flash('Benutzer erfolgreich gelöscht!')
    else:
        flash('Benutzer nicht gefunden!')

    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)
