from japanFunc import *
from varParams import LEN, row, col
import sys


BitRow = {} # variantele favorabile pentru ROW - pentru fiecare pozitie
BitCol = {} # variantele favorabile pentru COL - pentru fiecare pozitie

#repartizarea variantelor posibile
Initial  = [0]*LEN # combinatia posibila care fa fi verificata
CountCol = [0]*LEN  # cite combinatii intra in fiecare masivBitCol
CountRow = [0]*LEN

for i in range(2**LEN):
    # good
    x = prelungireCode(bin(i))  # 1011 => 0000001011
    
    array = bitGrup(x)          # 11000111001111 => [ 11, 111, 1111 ]
    

    # good
    for j in range(len(array)):
        array[j] = len(array[j])

    for k in range(LEN):

        if array == row[k]:
            try:
                BitRow[k]
            except:
                BitRow[k] = []
            BitRow[k].append(x) # all variants 11000111001111 11000111001111
            CountRow[k] += 1


        if array == col[k]:
            try:
                BitCol[k]
            except:
                BitCol[k] = []
            BitCol[k].append(x) # all variants 11000111001111 11000111001111
            CountCol[k] += 1


prodC =  array_product(CountCol) # variente posibile initiale
# print("combinatii COL - INTIAL = " + str(prodC) )

#######################################################################
# Filtru   Deplasare
#filtrarea lui BitCol si BitRow

for i in range(LEN):

    regR = filtruDeplasare(row[i])
    regC = filtruDeplasare(col[i])


    for j in range(LEN):

        if regR[j] == '1':
            for k in range( len(BitCol[j]) ):
                if regR[j] != BitCol[j][k][i]:

                    BitCol[j][k] = ""  
                    CountCol[j] -= 1

            while("" in BitCol[j]): 
                BitCol[j].remove("")

    for j in range(LEN):
        if regC[j] == '1':
            for k in range( len(BitRow[j]) ):
                if regC[j] != BitRow[j][k][i]:
                    BitRow[j][k] = ""  
                    CountRow[j] -= 1
            while("" in BitRow[j]): 
                BitRow[j].remove("")


prodC = array_product(CountCol)
print("combinatii COL - FILTRU ONE = " + str(prodC) ) 
# print(CountCol,"\n\n")


for i in range(LEN):
    regR = filtruZero(BitRow[i])
    
    # print(BitRow[i], regR)

    for j in range(LEN):
        
        if regR[j] == '0':
            
            for k in range( len(BitCol[j]) ) :
                
                if regR[j] != BitCol[j][k][i]:
                    BitCol[j][k] = ""  
                    CountCol[j] -= 1

            while("" in BitCol[j]): 
                BitCol[j].remove("")

prodC = array_product(CountCol)
print("combinatii COL - FILTRU ZERO " + str( prodC ) )
# print(CountCol, "\n\n");

final = {} # se salveaza rezultatul final


for i in range(int(prodC),0,-1):

    for n in range(LEN):

        a=list(BitCol[n][Initial[n]])

        for m in range(LEN):
          
            try:
                final[m]
            except:
                final[m] = {}
                final[m][n] = {}
            final[m][n] = a[m]

        check = 0

    for n in range(LEN):

        help = ''
        for m in range(LEN):
            
            if help in BitRow[n]:
                check = 0
                break
            else:
                check = 1

    if check == 1:

        for n in range(LEN):
            for m in range(LEN):
                if final[n][m] == '1':
                    final[n][m] ='#'
                else:
                    final[n][m] = '~'

                print(final[n][m], end ='')
            print('', end="\n")
        break
    
    Initial[LEN-1] += 1

    for k in range(LEN-1,1,-1):
        
        if Initial[k] ==  CountCol[k]:
            Initial[k]=0
            Initial[k-1] += 1
                        


