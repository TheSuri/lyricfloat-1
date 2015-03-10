Feature: Lyrics Test
    Test for the lyrics page and every functionality tied with it

    Scenario: Select Song Title
        Given I am on the song page
        	And song exists
        Then I can click on a song