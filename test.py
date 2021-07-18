from tkinter import *

root = Tk()

ob_fun ={
    "a" : c
    "b" : "k"
}

def click():
    print(ob_fun["a"])

btn = Button(root, text="클릭",command=click)

btn.pack()


root.mainloop()
