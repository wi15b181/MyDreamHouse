class EbooksController < ApplicationController
  def new



  end

  def show
    #$conn = IBM_DB.connect("DRIVER={IBM DB2 ODBC DRIVER};DATABASE=mdh;\
     #                  HOSTNAME=wi-gate.technikum-wien.at;PORT=60831;PROTOCOL=TCPIP;\
      #                 UID=mydreahmouse;PWD=wi15b;", "", "")
  end


  def create


    #render plain: params[:ebook].inspect
    @ebook = Ebook.new(params[:ebook][:ebook_id],params[:ebook][:titel], params[:ebook][:autor],
                       params[:ebook][:erscheinungsdatum], params[:ebook][:auflage], params[:ebook][:bild],
                       params[:ebook][:content], params[:ebook][:mimetype],params[:ebook][:filesize],params[:ebook][:active])

    #puts params[:titel]
    #conn = IBM_DB.connect("sample", "admin", "admin")
    #conn = IBM_DB.connect("DRIVER={IBM DB2 ODBC DRIVER};DATABASE=mdh;\
     #                  HOSTNAME=wi-gate.technikum-wien.at;PORT=60831;PROTOCOL=TCPIP;\
      #                 UID=mydreahmouse;PWD=wi15b;", "", "")

    conn = IBM_DB.connect("DRIVER={IBM DB2 ODBC DRIVER};DATABASE=mdh;\
                      HOSTNAME=wi-gate.technikum-wien.at;PORT=60831;PROTOCOL=TCPIP;\
                     UID=mydreahmouse;PWD=wi15b;", "", "")


    sql = "INSERT INTO EBOOK (EBOOK_ID, TITEL, AUTOR, ERSCHEINUNGSDATUM, AUFLAGE, BILD, CONTENT, MIMETYPE, FILESIZE, ACTIVE) VALUES('"+@ebook.ebook_id.to_s+"','"+@ebook.titel.to_s+"','"+@ebook.autor.to_s+"','"+@ebook.erscheinungsdatum.to_s+"','"+@ebook.auflage.to_s+"','"+@ebook.bild.to_s+"','"+@ebook.content.to_s+"','"+@ebook.mimetype.to_s+"','"+@ebook.filesize.to_s+"','"+@ebook.active.to_s+"')"


    IBM_DB.exec(conn, sql)
    #IBM_DB.free_result(stmt)
    #@ebook = Ebook.new(params[:ebook])

    #@ebook.save
    #redirect_to @ebook
    redirect_to "http://127.0.0.1:3000/ebooks/new", alert: "Neues Ebook angelegt."
  end
end
