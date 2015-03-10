Feature: Searching
	Test for seeing a search bar and button upon opening the site
	autocompleteing with a picture
	and sending a POST request upon submitting the search

    Scenario: Search Text Box
        Given I am on the home page
        Then I should see a search text box

    Scenario: Search Submit Button
        Given I am on the home page
        Then I should see a search text box
        	And I should see a submit button

    Scenario: Search Text Autocomplete
        Given I am on the home page
        	And there exists a search text box
        When I type "Avicii" in the search text box
        Then I should see autocompleted artists
        And ".ui-autocomplete" should be visible

    Scenario: Autocomplete Picture
        Given I am on the home page
        And that artists names autocomplete
        When I type "Avicii" in the search text box
        Then I should see a picture next to the autocomplete results

    Scenario: POST request sent
        Given I am on the home page
            And there exists a search text box
            And there exists a submit button
        When I type "Avicii" in the search text box
            And I click the "Submit" button
        Then I should be on the "LyricFloat - Word Cloud" page