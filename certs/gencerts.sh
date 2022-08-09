#!/usr/bin/bash

# 產生CA密鑰及根憑證
## 在提問的Common Name部份輸入 mineca.localhost
##openssl req -x509 -nodes -newkey rsa:4096 -keyout root-ca-key.pem -sha256 -days 3650 -out root-ca.crt
# 免提問版
openssl req -x509 -nodes -newkey rsa:4096 -keyout root-ca-key.pem -sha256 -days 3650 -out root-ca.crt -config ca.cnf

# 產生Server&Client密鑰及CSR
## 在提問的Common Name部份輸入 mineserver.localhost
##openssl req -nodes -sha256 -utf8 -newkey rsa:2048 -keyout server-key.pem -out server.csr
# 免提問版
openssl req -nodes -sha256 -utf8 -newkey rsa:2048 -keyout server-key.pem -out server.csr -config server.cnf

# 在提問的Common Name部份輸入 I'm a user
##openssl req -nodes -sha256 -utf8 -newkey rsa:2048 -keyout client-key.pem -out client.csr
# 免提問版
openssl req -nodes -sha256 -utf8 -newkey rsa:2048 -keyout client-key.pem -out client.csr -config client.cnf

# 使用ca的key和憑證分別對CSR簽署Server&Client的SSL憑證
openssl x509 -req -in server.csr -days 3650 -CA root-ca.crt -CAkey root-ca-key.pem -set_serial 01 -out server.crt
openssl x509 -req -in client.csr -days 3650 -CA root-ca.crt -CAkey root-ca-key.pem -set_serial 01 -out client.crt

# 警告:這不是安全的作法
# 預設key產生後只有擁有者可存取,但是掛載到docker內的ap和db存取時不是擁有者,所以就將key都加上可讀取權限
chmod +r *-key.pem

# 產出8個檔案
# 1. root-ca-key.pem
# 2. root-ca.crt
# 3. server-key.pem
# 4. server.csr
# 5. client-key.pem
# 6. client.csr
# 7. server.crt
# 8. client.crt

# 除錯:確認CA與簽出憑證合法
#openssl verify -CAfile root-ca.crt client.crt server.crt

# SSL連線除錯用
#ls -1 *.crt | xargs -ti openssl x509 -in {} -noout -subject -purpose -ext subjectAltName,keyUsage,extendedKeyUsage,nsComment