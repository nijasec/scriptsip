function getpip()
{
echo  "finding my ip"
newip=$(curl ifconfig.me/ip)
echo $newip
        if [[ "$currip" != "$newip" ]]; then
        echo "IP has changed ! Sending email"
        body=$msg_mail$newip
#       wsmtp -f "raspberrypi3@gmail.com" -t  $to_mail -s "${sub_mail}" -m "${body}"  -u $user_mail -p $passwd_mail -d $smtp_mail -i $smtp_port
#       curl -X POST -F 'dname=raspi_1' https://dclock.6te.net/logger.php
        currip=$newip
        dip=$(ifconfig wlan0 | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p')
        upnpc -a $dip 443 443 tcp
        echo $dip

        #stunnel /etc/stunnel/st.conf
        curl -X POST -F 'dname=raspi_1' -F "dlocalip=${dip}" https://dclock.6te.net/logger.php
       fi
}


timer=5
while :
do
   getpip
    sleep 180
  done
