from varParams import LEN


#good
def prelungireCode(a): # 1011 => 0000001011
    
    global LEN
    a = str(a)
    a = a.replace('0b',"")    
    return a.rjust(LEN,'0')
    

#good
def bitGrup(array): # 11000111001111 => [ 11, 111, 1111 ]
    array = array.split('0')
    while("" in array): 
        array.remove("")
    return array


# good    
def bit(a, key): #(times = 5,char(98+2) = d) => 'ddddd'
    return chr(98+key) * a


def array_product(arr):
	prod = 1

	for i in arr:
		prod *= i #variente posibile initiale

	return prod



# good
def filtruDeplasare(masiv): # 0b0ccc0d, b0ccc0d0 -> 00011000
    ver = []

    for i in range(len(masiv)):
        ver.append( bit(masiv[i], i) )

    arr = "0".join(ver)

    right = arr.rjust(LEN,'0')
    left  = arr.ljust(LEN,'0')

    # print(right, left)
    registor = []

    for i in range(LEN):
        if right[i] == left[i] and right[i] != '0':
            registor.append('1')
        else:
            registor.append('0')

    # return registor

    res_str = "".join(registor)

    return res_str


# good
def filtruZero(masiv): # ['00011110001', '00000111101'] -> 000aaaaaa0a 
    
    x = [0]*LEN

    for k in range( len(masiv) ):
        for j in range(LEN):
            x[j] += int( masiv[k][j] )


    for i in range(LEN):
        if x[i] != 0:
            x[i] = 'a'
        else:
            x[i] = '0'

    return "".join(x)

