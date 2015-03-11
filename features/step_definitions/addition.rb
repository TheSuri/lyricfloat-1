Given(/^there exists an add to cloud button$/) do
  page.has_button?('Add To Cloud')
end

Given(/^I am on the song page$/) do
  visit "/LyricFloat/word-cloud.php?artist_name=Dolores+Hayden"
  click_link('weighs')
end

Given(/^song exists$/) do
  page.find('.lyrics').find('li')
end

Then(/^I can click on a song$/) do
  pending # express the regexp above with the code you wish you had
end