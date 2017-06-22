class Hauspaket_attribut_regel
	attr_reader :regel_id,:regel_attribut_left_id,:regel_attribut_right_id,:regel_preis_modifikator,:regel_erlaubt,:archived
	def initialize(regel_id,regel_attribut_left_id,regel_attribut_right_id,regel_preis_modifikator,regel_erlaubt,archived)

		@:regel_id=regel_id
		@:regel_attribut_left_id=regel_attribut_left_id
		@:regel_attribut_right_id=regel_attribut_right_id
		@:regel_preis_modifikator=regel_preis_modifikator
		@:regel_erlaubt=regel_erlaubt
		@:archived=archived
		
	end
end