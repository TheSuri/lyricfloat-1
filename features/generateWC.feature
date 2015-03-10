Feature: Generate WC
	Test for seeing a search bar and button upon opening the site
	autocompleteing with a picture
	and sending a POST request upon submitting the search

    Scenario: Display Words
        Given I am on the word cloud page
        And there is an existing word cloud 
        Then I should see a search text box