
Then(/^"(.*?)" should be visible$/) do |content|
	find(content).visible?
end

When(/^I click the "(.*?)" button$/) do |element|
    click_button(element)
end

Then(/^I should be taken to the "(.*?)" page/) do |page|
	has_title?(page)
end