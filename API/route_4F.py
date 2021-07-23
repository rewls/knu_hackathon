request_data = {'search_section':"4-3", 'start_section':"4-2", 'end_section':"4-4", 'shelf_group': [{"group":"4L","shelf":["85"]},{"group":"4Z","shelf":["156","172"]}]}
search_section = request_data['search_section']
start_section = request_data['start_section']
end_section = request_data['end_section']
shelf_group = request_data['shelf_group']

sections = ['4-1', '4-2', '4-3', '4-4', '4-A', '4-B', '4-C']
sections_dir = ['4-A', '4-1', '4-2', '4-B', '4-3', '4-C', '4-4']
comb_sections = [{'1','2'}, {'2','3'}, {'3','4'}, {'A','B'}, {'1','A'}, {'1','B'}, {'2','A'}, {'2','B'}, {'3','B'}, {'3','A'}, {'4','A'}, {'4','B'}, {'2','C'}, {'3','C'}, {'4','C'}, {'1','3'}, {'1','4'}, {'2','4'}, {'B','C'}, {'A','C'}, {'1','C'}]
cur_section = start_section
start2search = {start_section[-1], search_section[-1]}
search2end = {search_section[-1], end_section[-1]}
route = [start_section, search_section, end_section]
shelf_groups_dir = [['4T', '4S', '4R', '4Q', '4P'], ['4G', '4F', '4H', '4E', '4C', '4B', '4A', '4D', '4I'], ['4J', '4K', '4L', '4Z', '4M', '4N', '4O'], ['4U', '4V', '4W', '4X', '4Y']]
door_case = [2, 3, 4, 5, 6, 7, [2, 5], [3, 5], [4, 6], [5, 7], [2, 5, 7]]
pass_doors = []
shelf = []
shelf_num = {}
result_api2_2 = []

def clockwize():
    section_dir = []
    if route[0] == route[2]:
        section_dir = route
    else:
        for i in range(len(sections_dir)):
            for j in range(len(route)):
                if route[j] == sections_dir[i]:
                    section_dir.append(sections_dir[i])
    return section_dir

def fix_order():
    if cur_section in sections[:4]:
        if route == clockwize():
            temp = shelf_groups_dir[int(cur_section[-1])-1]
            for j in range(len(temp)):
                for i in range(len(shelf)):
                    temp2 = {}
                    if (shelf[i] in temp) and (shelf[i] == temp[j]):
                        temp2['group'] = shelf[i]
                        temp2['shelf'] = shelf_num[shelf[i]]
                        shelf_group.append(temp2)
        else:
            temp = shelf_groups_dir[int(cur_section[-1])-1]
            for j in range(len(temp)-1,-1,-1):
                for i in range(len(shelf)):
                    temp2 = {}
                    if (shelf[i] in temp) and (shelf[i] == temp[j]):
                        temp2['group'] = shelf[i]
                        temp2['shelf'] = shelf_num[shelf[i]]
                        shelf_group.append(temp2)

        for i in range(len(shelf_group)):
            result_api2_2.append(shelf_group[i])

def result(route_portion):
    global pass_doors
    pass_doors = []
    for i in range(len(comb_sections)):    # door
        if route_portion == comb_sections[i]:
            if 0 <= i < 4: pass_doors = []
            elif 4 <= i < 6: pass_doors = [2]
            elif 6 <= i < 8: pass_doors = [3]
            elif 8 <= i < 9: pass_doors = [4]
            elif 9 <= i < 12: pass_doors = [5]
            elif 12 <= i < 14: pass_doors = [6]
            elif 14 <= i < 15: pass_doors = [7]
            elif 15 <= i < 17: pass_doors = [2,5]
            elif 17 <= i < 18: pass_doors = [3,5]
            elif 18 <= i < 19: pass_doors = [4,6]
            elif 19 <= i < 20: pass_doors = [5,7]
            elif 20 <= i < 21: pass_doors = [2,5,7]

    for i in range(len(pass_doors)):
        pass_doors[i] = "door2-"+str(pass_doors[i])
    
    fix_order()
    
    for i in range(len(pass_doors)):
        result_api2_2.append(pass_doors[i])


for i in range(len(shelf_group)):
    shelf.append(shelf_group[i]['group'])
    shelf_num[shelf[i]] = shelf_group[i]['shelf']

shelf_group = []

result_api2_2.append(start_section)

result(start2search)
cur_section = search_section

result(search2end)
cur_section = end_section

result_api2_2.append(end_section)

print(result_api2_2)

# ["2-B","door2-3",{"group":"2A","shelf":["5"]},{"group":"2C","shelf":["51"]},"2-1"]