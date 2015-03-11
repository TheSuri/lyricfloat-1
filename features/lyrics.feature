Feature: Lyrics Test
    Test for the lyrics page and every functionality tied with it

    Scenario: Go to Lyrics Page
        Given I am on the song page
            And song exists
        When I can click on a song
        Then I should be on the "LyricFloat - Lyrics Page" page

    Scenario: highlight word
    	Given I am on the lyrics page
    	Then there should be highlighted words
    	