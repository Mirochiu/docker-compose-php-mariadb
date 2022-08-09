# PHP-Apache-MariaDB for Development

## 使用前須知

1. 由於AP與DB溝通啟用了SSL/TLS雙向安全溝通模式，所以需要使用`certs/gencerts.sh`生成私鑰與憑證才能啟動此環境。
1. `certs/gencerts.sh`需要本機有bash並安裝openssl才能生成，如果有遭遇問題請提issue，感恩!
1. 關於DB的帳號密碼, 請先寫在`.env`檔案內再啟動環境
1. 由於環境使用`docker-compose`請先在本機安裝好
1. 此環境設定為`+8`時區

## 基本操作

1. 進入本專案根目錄

1. 背景啟動環境
`docker-compose up -d`

1. 關閉環境
`docker-compose down`

1. 本機瀏覽器開啟網頁
http://localhost:3000

## DB操作

- 本機mysql client想連入MariaDB
   `mysql -h localhost -P 3306 -u ap -p`
   雖然環境啟用了SSL/TLS雙向安全溝通模式，但是MariaDB官方image的預設使用者並不會套用這個設定，所以還是可以直接連入。

- 本機想用MariaDB的root帳號
   無法本機連入時使用root帳號，因為我在MariaDB有設定了一般使用者帳號；但是你可以進入container內使用mysql client登入root帳號。
   1. `docker exec -it backend-db bash`
   1. `mysql -u root -p`

- 設定使用者為雙向溝通模式
    以預設使用者`ap`舉例
   1. 使用root帳號連入MariaDB。
   1. 修改登入方式成x509憑證登入。
      `ALTER USER 'ap'@'%' REQUIRE X509;`

## php程式碼

請直接編修src中的程式碼再刷新網頁。

## Troubleshooting

啟動環境時總是說失敗

1. 確認你的本機port沒有佔用3000和3306；或是不會確認佔用狀態，就請改變一下`docker-compose.yml`內的port設定
1. 請將你的錯誤訊息截圖丟issue，我再確認一下少了什麼。
