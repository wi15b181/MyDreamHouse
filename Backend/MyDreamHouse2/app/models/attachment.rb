class Attachment
  attr_reader :attachment_id,:filename,:bezeichnung,:filesize,:mimetype,:hauspaket_id,:archived
  def initialize(attachment_id,filename,bezeichnung,filesize,mimetype,hauspaket_id,archived)

    @attachment_id=attachment_id
    @filename=filename
    @bezeichnung=bezeichnung
    @filesize=filesize
    @mimetype=mimetype
    @hauspaket_id=hauspaket_id
    @archived=archived
  end
end