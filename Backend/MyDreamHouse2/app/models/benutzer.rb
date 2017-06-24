class Benutzer
	attr_reader :benutzer_id,:joomla_user_id,:archived
	def initialize(benutzer_id,joomla_user_id,archived)

		@benutzer_id=benutzer_id
		@joomla_user_id=joomla_user_id
		@archived=archived
		
	end
end