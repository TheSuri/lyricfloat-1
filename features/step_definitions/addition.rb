Given(/^there exists an add to cloud button$/) do
  page.has_button?('Add To Cloud')
end

Given(/^I am on the song page$/) do
  visit "/LyricFloat/word-cloud.php?artist_name=my+favorite+highway"
  click_link('highway')
end

Given(/^song exists$/) do
  visit "/LyricFloat/song-page.php?searched-word=highway"
  page.find('.lyrics').find('li')
end

Then(/^I can click on a song$/) do
  pending # express the regexp above with the code you wish you had
end