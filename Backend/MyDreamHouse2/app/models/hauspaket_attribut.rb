class Hauspaket_attribut
	attr_reader :attribut_id,:attribut_typ,:attribut_typ_anzeige
	def initialize(attribut_id,attribut_typ,attribut_typ_anzeige)

		@attribut_id=attribut_id
		@attribut_typ=attribut_typ
		@attribut_typ_anzeige=attribut_typ_anzeige
		
	end
end