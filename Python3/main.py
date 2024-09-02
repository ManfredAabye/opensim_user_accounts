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
