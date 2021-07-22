def add_shelf_group():
    for i in range(len(shelf_group)):
        for j in range(len(shelf_groups)):
            print(shelf_group[i]['group'], shelf_groups[j])
            if shelf_group[i]['group'] in shelf_groups[j]:
                print(cur_section, sections[j])
                if cur_section == sections[j]:
                    result_api2_2.append(shelf_group[i]) 

def result(route):
    pass_doors = []
    for i in range(len(comb_sections)):    # door
        if route == comb_sections[i]:
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

    add_shelf_group()
    
    for i in range(len(pass_doors)):
        result_api2_2.append(pass_doors[i])

request_data = {'search_section':"2-2", 'start_section':"2-B", 'end_section':"2-1", 'shelf_group': [{"group":"2A","shelf":["5"]},{"group":"2C","shelf":["51"]}]}
search_section = request_data['search_section']
start_section = request_data['start_section']
end_section = request_data['end_section']
shelf_group = request_data['shelf_group']

sections = ['2-1', '2-2', '2-3', '2-4', '2-A', '2-B', '2-C']
door_case = [2, 3, 4, 5, 6, 7, [2, 5], [3, 5], [4, 6], [5, 7], [2, 5, 7]]
comb_sections = [{'1','2'}, {'2','3'}, {'3','4'}, {'A','B'}, {'1','A'}, {'1','B'}, {'2','A'}, {'2','B'}, {'3','B'}, {'3','A'}, {'4','A'}, {'4','B'}, {'2','C'}, {'3','C'}, {'4','C'}, {'1','3'}, {'1','4'}, {'2','4'}, {'B','C'}, {'A','C'}, {'1','C'}]
shelf_groups = [['2E', '2F', '2G', '2H', '2I', '2J', '2K', '2L', '2M'], ['2A', '2B', '2C', '2D', '2N'], ['2T', '2U', '2O'], ['2P', '2Q', '2R', '2S']]
cur_section = start_section
start2search = {start_section[-1], search_section[-1]}
search2end = {search_section[-1], start_section[-1]}
result_api2_2 = []
route = 0

result_api2_2.append(start_section)

result(start2search)
cur_section = search_section

result(search2end)
cur_section = end_section

result_api2_2.append(end_section)

print(result_api2_2)

# ["2-B","door2-3",{"group":"2A","shelf":["5"]},{"group":"2C","shelf":["51"]},"2-1"]