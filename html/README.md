Um eine HTML-Seite zu erstellen, die es ermöglicht, Benutzerkonten anzulegen, Passwörter zu ändern und Benutzerkonten zu löschen, verwenden wir Python 3 in Kombination mit dem Flask-Webframework. Flask ist ein einfaches und leichtes Framework, das sich gut für solche Aufgaben eignet.

### Struktur des Projekts

1. **app.py** - Haupt-Python-Datei für die Flask-Anwendung.
2. **templates/**
    - **index.html** - Die HTML-Datei für das Frontend.

### Schritt 1: Installation von Flask

Zuerst müssen wir Flask installieren. Dies kann über pip erfolgen:

```bash
pip install flask
```

### Schritt 2: Erstellen der `app.py`

```python
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
```

### Schritt 3: Erstellen der `index.html`

Erstellen Sie einen Ordner namens `templates` und legen Sie darin die Datei `index.html` ab:

```html
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
        }
        form {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
        }
        .success {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>User Management</h1>
    
    {% with messages = get_flashed_messages(with_categories=true) %}
      {% if messages %}
        {% for category, message in messages %}
          <div class="alert {{ category }}">{{ message }}</div>
        {% endfor %}
      {% endif %}
    {% endwith %}
    
    <h2>User anlegen</h2>
    <form method="post" action="/create_user">
        <input type="text" name="first_name" placeholder="Vorname" required>
        <input type="text" name="last_name" placeholder="Nachname" required>
        <input type="password" name="password" placeholder="Passwort" required>
        <input type="text" name="principal_id" placeholder="Principal ID" required>
        <button type="submit">User anlegen</button>
    </form>

    <h2>Passwort ändern</h2>
    <form method="post" action="/change_password">
        <input type="text" name="principal_id" placeholder="Principal ID" required>
        <input type="password" name="new_password" placeholder="Neues Passwort" required>
        <button type="submit">Passwort ändern</button>
    </form>

    <h2>User löschen</h2>
    <form method="post" action="/delete_user">
        <input type="text" name="principal_id" placeholder="Principal ID" required>
        <button type="submit">User löschen</button>
    </form>
</body>
</html>
```

### Schritt 4: Starten der Anwendung

Sie können die Flask-Anwendung starten, indem Sie das folgende Kommando im Verzeichnis mit Ihrer `app.py` ausführen:

```bash
python app.py
```

Rufen Sie dann `http://127.0.0.1:5000/` in Ihrem Webbrowser auf, um die Anwendung zu verwenden.

### Funktionsweise

- **User anlegen:** Füllt die Felder aus und sendet das Formular ab. Der Benutzer wird in der simulierten Datenbank erstellt.
- **Passwort ändern:** Geben Sie die Principal ID und das neue Passwort ein, um das Passwort eines Benutzers zu ändern.
- **User löschen:** Geben Sie die Principal ID ein, um den Benutzer zu löschen.

Diese Anwendung dient als Basis. In einer realen Umgebung würden Sie die Daten in einer echten Datenbank speichern und entsprechende Sicherheitsmaßnahmen wie Authentifizierung und SSL-Verschlüsselung verwenden.
