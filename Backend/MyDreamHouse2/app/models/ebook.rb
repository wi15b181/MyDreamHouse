class Ebook

	attr_accessor :ebook_id, :titel, :autor, :erscheinungsdatum, :auflage, :bild, :content, :mimetype, :filesize, :active
	attr_reader :ebook_id, :titel, :autor, :erscheinungsdatum, :auflage, :bild, :content, :mimetype, :filesize, :active
	def initialize(ebook_id, titel, autor, erscheinungsdatum, auflage, bild, content, mimetype, filesize, active)

		@ebook_id=ebook_id
		@titel=titel
		@autor=autor
		@erscheinungsdatum=erscheinungsdatum
		@auflage=auflage
		@bild=bild
		@content=content
		@mimetype=mimetype
		@filesize=filesize
		@active=active
		
	end

	def attrs
	  instance_variables.map{|ivar| instance_variable_get ivar}
	end
end