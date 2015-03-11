Given(/^I am on the lyrics page$/) do
  visit "/LyricFloat/lyrics-page.php?artists[]=Coldplay&song_name=Magic&artist=Coldplay&searched_word=magic"
end

Then(/^there should be highlighted words$/) do
  page.find('.lyrics').has_css?('span')
end

When(/^I can click on a song$/) do
	click_link('Magic (9)')
end