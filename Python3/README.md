Hier ist ein einfaches Programm, das in Python 3 geschrieben wurde und eine Benutzeroberfläche mit Tkinter bietet. Es ermöglicht das Erstellen von Benutzerkonten, das Ändern von Passwörtern und das Löschen von Benutzern. Die Benutzerdaten werden in einer einfachen SQLite-Datenbank gespeichert.

### Programmstruktur

- `main.py`: Hauptskript, das die GUI startet und die Benutzerinteraktionen verwaltet.
- `database.py`: Modul zur Verwaltung der SQLite-Datenbank.

### `database.py` - Datenbankmanagement

```python
import sqlite3

def initialize_db():
    conn = sqlite3.connect('users.db')
    c = conn.cursor()
    c.execute('''CREATE TABLE IF NOT EXISTS users (
                 id INTEGER PRIMARY KEY AUTOINCREMENT,
                 username TEXT UNIQUE,
                 password TEXT)''')
    conn.commit()
    conn.close()

def create_user(username, password):
    conn = sqlite3.connect('users.db')
    c = conn.cursor()
    try:
        c.execute('INSERT INTO users (username, password) VALUES (?, ?)', (username, password))
        conn.commit()
    except sqlite3.IntegrityError:
        return False
    finally:
        conn.close()
    return True

def change_password(username, new_password):
    conn = sqlite3.connect('users.db')
    c = conn.cursor()
    c.execute('UPDATE users SET password = ? WHERE username = ?', (new_password, username))
    conn.commit()
    conn.close()

def delete_user(username):
    conn = sqlite3.connect('users.db')
    c = conn.cursor()
    c.execute('DELETE FROM users WHERE username = ?', (username,))
    conn.commit()
    conn.close()

def user_exists(username):
    conn = sqlite3.connect('users.db')
    c = conn.cursor()
    c.execute('SELECT * FROM users WHERE username = ?', (username,))
    user = c.fetchone()
    conn.close()
    return user is not None
```

### `main.py` - Hauptanwendung mit Tkinter GUI

```python
import tkinter as tk
from tkinter import messagebox
import database

def create_user():
    username = entry_username.get()
    password = entry_password.get()

    if not username or not password:
        messagebox.showerror("Fehler", "Benutzername und Passwort dürfen nicht leer sein.")
        return

    if database.create_user(username, password):
        messagebox.showinfo("Erfolg", "Benutzer erfolgreich erstellt.")
    else:
        messagebox.showerror("Fehler", "Benutzername bereits vergeben.")

def change_password():
    username = entry_username.get()
    new_password = entry_password.get()

    if not username or not new_password:
        messagebox.showerror("Fehler", "Benutzername und Passwort dürfen nicht leer sein.")
        return

    if database.user_exists(username):
        database.change_password(username, new_password)
        messagebox.showinfo("Erfolg", "Passwort erfolgreich geändert.")
    else:
        messagebox.showerror("Fehler", "Benutzer existiert nicht.")

def delete_user():
    username = entry_username.get()

    if not username:
        messagebox.showerror("Fehler", "Benutzername darf nicht leer sein.")
        return

    if database.user_exists(username):
        database.delete_user(username)
        messagebox.showinfo("Erfolg", "Benutzer erfolgreich gelöscht.")
    else:
        messagebox.showerror("Fehler", "Benutzer existiert nicht.")

# Initialisiere die Datenbank
database.initialize_db()

# Erstelle das Hauptfenster
root = tk.Tk()
root.title("Benutzerverwaltung")

# Benutzeroberfläche
frame = tk.Frame(root)
frame.pack(pady=20)

label_username = tk.Label(frame, text="Benutzername")
label_username.grid(row=0, column=0, padx=10, pady=10)

entry_username = tk.Entry(frame)
entry_username.grid(row=0, column=1, padx=10, pady=10)

label_password = tk.Label(frame, text="Passwort")
label_password.grid(row=1, column=0, padx=10, pady=10)

entry_password = tk.Entry(frame, show="*")
entry_password.grid(row=1, column=1, padx=10, pady=10)

btn_create_user = tk.Button(frame, text="Benutzer erstellen", command=create_user)
btn_create_user.grid(row=2, column=0, padx=10, pady=10)

btn_change_password = tk.Button(frame, text="Passwort ändern", command=change_password)
btn_change_password.grid(row=2, column=1, padx=10, pady=10)

btn_delete_user = tk.Button(frame, text="Benutzer löschen", command=delete_user)
btn_delete_user.grid(row=3, column=0, columnspan=2, padx=10, pady=10)

# Starte die Anwendung
root.mainloop()
```

### Erklärung

- **Tkinter GUI**: Das Hauptfenster enthält Eingabefelder für den Benutzernamen und das Passwort, sowie Schaltflächen zum Erstellen eines Benutzers, Ändern des Passworts und Löschen des Benutzers.
  
- **Datenbank**: Die Benutzerdaten werden in einer SQLite-Datenbank (`users.db`) gespeichert. Dies ermöglicht die persistente Speicherung der Daten.

- **Funktionalitäten**:
  - **Benutzer erstellen**: Erstellt einen neuen Benutzer in der Datenbank, sofern der Benutzername noch nicht vergeben ist.
  - **Passwort ändern**: Ändert das Passwort eines bestehenden Benutzers.
  - **Benutzer löschen**: Löscht einen Benutzer aus der Datenbank.

- **Fehlerbehandlung**: Wenn Eingaben fehlen oder Fehler auftreten (z.B. Benutzername bereits vergeben), wird der Benutzer über ein Popup-Fenster informiert.

### Anforderungen

- Python 3
- Tkinter (standardmäßig in Python enthalten)
- SQLite (standardmäßig in Python enthalten)

### Ausführung

Speichere beide Dateien (`main.py` und `database.py`) im selben Verzeichnis und führe `main.py` aus, um die Anwendung zu starten.
