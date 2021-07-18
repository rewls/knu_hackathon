from tkinter import *
import requests
import sys
print(sys.executable)
root = Tk()

def click():
    r = requests.get("http://google.com")
    print(r.text)

btn = Button(root, text="클릭",command=click)

btn.pack()


root.mainloop()
