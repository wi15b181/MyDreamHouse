class ApplicationController < ActionController::Base
 # def index
  #end
  $conn = IBM_DB.connect("DRIVER={IBM DB2 ODBC DRIVER};DATABASE=mdh;\
                       HOSTNAME=wi-gate.technikum-wien.at;PORT=60831;PROTOCOL=TCPIP;\
                       UID=mydreahmouse;PWD=wi15b;", "", "")
  protect_from_forgery with: :exception
end
