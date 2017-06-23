class Hauspaket
	attr_reader :hauspaket_id,:hersteller_id,:berater_id,:bezeichnung,:preis,:grundflaeche,:wohnflaeche,:stockwerke,:benutzer_id,:archived
	def initialize(hauspaket_id,hersteller_id,berater_id,bezeichnung,preis,grundflaeche,wohnflaeche,stockwerke,benutzer_id,archived)

		@:hauspaket_id=hauspaket_id
		@:hersteller_id=hersteller_id
		@:berater_id=berater_id
		@:bezeichnung=bezeichnung
		@:preis=preis
		@:grundflaeche=grundflaeche
		@:wohnflaeche=wohnflaeche
		@:stockwerke=stockwerke
		@:benutzer_id=benutzer_id
		@:archived=archived
		
	end
end