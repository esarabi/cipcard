import ftplib
import os

FTP_HOST = "45.139.11.86"
FTP_USER = "root@cipcard.ir"
FTP_PASS = "!q1w2e3r4t5.."

local_file = r"C:\Users\Ershad\.gemini\antigravity\scratch\cipcard\views\auth\login.php"

ftp = ftplib.FTP(FTP_HOST, timeout=30)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd("public_html/views/auth")

with open(local_file, "rb") as f:
    ftp.storbinary("STOR login.php", f)

ftp.quit()
print("Uploaded views/auth/login.php successfully.")
