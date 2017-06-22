class Ebook
  #self.table_name = "EBOOK"
  #set_primary_key 'EBOOK_ID'
  def initialize(bild,benutzerId)
    @Bild = bild
    @BenutzerId = benutzerId
  end
end
