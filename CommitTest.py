from tkinter import *
import os

def MakeitPy(name, path, code):
    ActualPath = path + "\\" + name + ".py"
    with open(ActualPath, 'w', encoding='utf-8') as F:
        F.write(code)
    Status = Label(root, text = "\""+ str(name)+".py\" has been created!")
    Status.grid(column=1, row=3)

File_name = ""
Path = ""
Code = ""

root = Tk()
root.title("Easy2Py")
root.geometry('300x90')
root.resizable(False, False)

Code_Fname_label = Label(root, text = "File Name Input")
Code_Fname_label.grid(column=0,row=0, padx = 15)
Code_Fname = Entry(root, textvariable=File_name)
Code_Fname.grid(column=1, row=0)

File_path_label = Label(root, text = "File Path Input")
File_path_label.grid(column=0,row=1)
File_path = Entry(root, textvariable=Path)
File_path.insert(0, str(os.getcwd()))
File_path.grid(column=1,row=1)

Code_label = Label(root, text="Code Input")
Code_label.grid(column=0,row=2)
Code_input = Entry(root, textvariable=Code)
Code_input.grid(column=1,row=2)

button = Button(root, text="Make it Py!", command=lambda: MakeitPy(Code_Fname.get(), File_path.get(), Code_input.get()))
button.grid(column=0, row=3)

root.mainloop()