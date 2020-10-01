from japanFunc import bit


def filtruDeplasare(masiv):
    ver = []

    for i in range(len(masiv)):
        ver.append( bit(masiv[i], i) )

    arr = "0".join(ver)

    right = arr.rjust(LEN,'0')
    left  = arr.ljust(LEN,'0')

    print(right, left)
    registor = []

    for i in range(LEN):
        if right[i] == left[i] and right != '0':
            registor.append('1')
        else:
            registor.append('0')

    # return registor

    res_str = "".join(registor)

    return res_str


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

