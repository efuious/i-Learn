import re
#1将字符串中，字母i单独出现的地方将i变为I
s='i am is wang i love I love you i!'
patter=re.compile(r'\bi\bi{0}')
print(patter)
print(re.sub(patter,'I',s)) #方法一
print(re.sub(r'\bi\bi{0}','I',s))#方法二使用原始字符串，减少输入字符的数量
print(re.sub('\\bi\\bi{0}','I',s))    #方法三使用"\"开头的元字符
print(re.sub('\\bi\\b','I',s))
#print(re.sub(r'\bl.*?\b','A',s))   #匹配所有以l开头的单词并替换为A
#print(re.sub('\\bl.+?\\b','A',s))
print('',end='\n')

#2把字符串中字母I位于单词中出现的地方组转换为小写
s1='I love you and hIs bautIfule nIce!'
patter1=re.compile(r'\BI+')
print(re.sub('\\BI+','i',s1))
print(re.sub(patter1,'i',s1))
print('',end='\n')

#3把单词连续重复出现的删除其一
s2='I love you you are my favorite girl!'
s0='abaaadcbdd'
patter2=re.compile('([a-zA-Z])\\1+')
print(re.sub(patter2,' ',s0),end='\n')
print(re.split('[\s]+',s2))         #分割时会保留其他字符,如!
print(re.findall('[a-zA-Z!]+',s2))   #findall()会根据指定内容划分
#print(re.sub(r'(.)\\5+','',s2))
r2=re.findall('[a-zA-Z!]+',s2)
print(' '.join(r2),end='\n')      #合并为原字符串
print(re.sub(r'(.)\\1+','',s2))
print('\n')

#4驻留机制的代码分析
s3='1234'
sS='1234'
print('短字符串id:')
print(id(s3))
print(id(sS))
print(id(s3)==id(sS))
s3=s3 * 100
sS=sS * 100
print('改变后长字符串id')
print(id(s3))
print(id(sS))
print(id(s3)==id(sS))   #短字符串具有驻留性，但对变量进行分别变长后，地址发生变化
print('',end='\n')



#5用户输入一段英文，输出所有长度为3的单词
s4=str(input("Please input an nice his  you english story:"))
patter4=re.compile(r'\b[\w+]{3}\b')
#print(re.search(patter4,s4))
print(' '.join(re.findall(patter4,s4)),end='\n')    #方法一
#print(re.sub('^\b[\w+]{3}\b','',s4))    #方法二