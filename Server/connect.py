import requests

username = 'Jongha'
try :
    url = 'http://118.67.129.164/maker/upload1.php'
    files = {'files':open('jg2.jpg','rb')}
    datas  = {'username':username}
    l = requests.post(url,files=files,data=datas)
    print(l.text)
except:
    print("")
    