class Ebook
	attr_reader :ebook_id,:titel,:autor,:erscheinungsdatum,:auflage,:bild,:content,:mimetype,:filesize,:active
	def initialize(ebook_id,titel,autor,erscheinungsdatum,auflage,bild,content,mimetype,filesize,active)

		@:ebook_id=ebook_id
		@:titel=titel
		@:autor=autor
		@:erscheinungsdatum=erscheinungsdatum
		@:auflage=auflage
		@:bild=bild
		@:content=content
		@:mimetype=mimetype
		@:filesize=filesize
		@:active=active
		
	end
end