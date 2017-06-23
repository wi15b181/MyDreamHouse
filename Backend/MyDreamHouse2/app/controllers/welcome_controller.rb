class WelcomeController < ApplicationController
  def index
    #format.json  { render :partial  => @ebook}
    respond_to do |format|

      format.html # show.html.erb
      format.json { render json: @dog }

    end
  end
  def show

  end
end
