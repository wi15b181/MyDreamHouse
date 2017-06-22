class EbooksController < ApplicationController
  def new
  end

  def create
    #render plain: params[:ebook].inspect

    ebook = Ebook.new(params[:ebook])

    @ebook.save
    redirect_to @ebook
  end
end
