class Hauspaket_attribut_wert
	attr_reader :wert_id,:attribut_id,:wert_text,:wert_ordnung,:archived
	def initialize(wert_id,attribut_id,wert_text,wert_ordnung,archived)

		@:wert_id=wert_id
		@:attribut_id=attribut_id
		@:wert_text=wert_text
		@:wert_ordnung=wert_ordnung
		@:archived=archived
		
	end
end