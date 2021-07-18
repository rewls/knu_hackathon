from tkinter import *

root = Tk()

def click():
    print("asdf")

btn = Button(root, text="클릭",command=click)

btn.pack()


root.mainloop()
