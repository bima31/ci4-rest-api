# CodeIgniter 4 Rest Api + JWT Auth

## Cara Penggunaan
- Min menggunakan PHP ver 7
- Import DD di Mysql "ci4.sql"
- file env ganti .env
- Start "php spark serve" -> localhost:8080

## Rute Api link
- http://localhost:8080/auth/register
  type POST x-www-form-urlencoded : nama, bidang, email, username, password
- http://localhost:8080/login
  type POST x-www-form-urlencoded : username, password
- http://localhost:8080/api/create
  type POST x-www-form-urlencoded : nama, tgl_masuk, no_tagihan, nominal
- http://localhost:8080/api/create_guest
  type POST x-www-form-urlencoded : id_monitoring
- http://localhost:8080/api/monitoring
  type GET
