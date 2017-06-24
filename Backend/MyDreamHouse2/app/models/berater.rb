class Berater
	attr_reader :berater_id,:hersteller_id,:benutzer_id,:bild,:archived
	def initialize(berater_id,hersteller_id,benutzer_id,bild,archived)

		@berater_id=berater_id
		@hersteller_id=hersteller_id
		@benutzer_id=benutzer_id
		@bild=bild
		@archived=archived
		
	end
end