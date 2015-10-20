Given(/^there is an add to cloud button$/) do
  page.has_button?('Add To Cloud')
end

Given(/^I am on the song page$/) do
  visit "/LyricFloat/song-page.php?artists[]=Coldplay&searched-word=magic"
end

Given(/^song exists$/) do
  page.find('.lyrics').find('li')
end