class Dog

  #THIS IS JUST A TESTING MODEL

  #attr_accessor :legs, :color
  attr_reader :legs, :color

  def setDog(l, c)
    @legs = l
    @color = c
    puts "dog created"
    puts @legs
  end
  #def attrs
  #  instance_variables.map{|ivar| instance_variable_get ivar}
  #end
end