class Dog

  attr_accessor :legs, :color

  def setDog(l, c)
    @legs = l
    @color = c
    puts "dog created"
    puts @legs
  end
  def attrs
    instance_variables.map{|ivar| instance_variable_get ivar}
  end
end