<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        [
            ["text"=>"Your mood can change very quickly.", "U"],
            ["text"=>"You rarely feel insecure.", "U"],
            ["text"=>"You feel very anxious in stressful situations", "U"],
            ["text"=>"Your work style is closer to random energy spikes than to a methodical and organized approach.", "U"],
            ["text"=>"People can rarely upset you.",	"T"],
            ["text"=>"Logic is usually more important than heart when it comes to making important decisions.",	"T"],
            ["text"=>"Being right is more important than being cooperative when it comes to teamwork.",	"T"],
            ["text"=>"It is often difficult for you to relate to other people’s feelings.",	"T"],
            ["text"=>"In a discussion, truth should be more important than people’s sensitivities.",	"T"],
            ["text"=>"You rarely do something just out of sheer curiosity.",	"S"],
            ["text"=>"You consider yourself more practical than creative.",	"S"],
            ["text"=>"You rarely get carried away by fantasies and ideas.",	"S"],
            ["text"=>"Your dreams tend to focus on the real world and its events.",	"S"],
            ["text"=>"You would not call yourself a dreamer.",	"S"],
            ["text"=>"Generally speaking, you rely more on your experience than your imagination.",	"S"],
            ["text"=>"You are more of a natural improviser than a careful planner",	"P"],
            ["text"=>"You would rather improvise than spend time coming up with a detailed plan.",	"P"],
            ["text"=>"Keeping your options open is more important than having a to-do list.",	"P"],
            ["text"=>"You often contemplate the reasons for human existence.",	"N"],
            ["text"=>"You frequently misplace your things.",	"N"],
            ["text"=>"You often get so lost in thoughts that you ignore or forget your surroundings.",	"N"],
            ["text"=>"You often find yourself lost in thought when you are walking in nature.",	"N"],
            ["text"=>"You often spend time exploring unrealistic and impractical yet intriguing ideas.",	"N"],
            ["text"=>"Your mind is always buzzing with unexplored ideas and plans.",	"N"],
            ["text"=>"You have always been interested in unconventional and ambiguous things, e.g. in books, art, or movies",	"N"],
            ["text"=>"Your home and work environments are quite tidy",	"J"],
            ["text"=>"Your travel plans are usually well thought out.",	"J"],
            ["text"=>"Being able to develop a plan and stick to it is the most important part of every project.","J"],
            ["text"=>"You have no difficulties coming up with a personal timetable and sticking to it.",	"J"],
            ["text"=>"You try to respond to your e-mails as soon as possible and cannot stand a messy inbox.",	"J"],
            ["text"=>"Being organized is more important to you than being adaptable",	"J"],
            ["text"=>"You find it difficult to introduce yourself to other people",	"I"],
            ["text"=>"You do not usually initiate conversations.",	"I"],
            ["text"=>"You rarely worry about how your actions affect other people.",	"I"],
            ["text"=>"You are a relatively reserved and quiet person.",	"I"],
            ["text"=>"You usually find it difficult to relax when talking in front of many people.",	"I"],
            ["text"=>"If the room is full, you stay closer to the walls, avoiding the center",	"I"],
            ["text"=>"An interesting book or a video game is often better than a social event.",	"I"],
            ["text"=>"As a parent, you would rather see your child grow up kind than smart.",	"F"],
            ["text"=>"If your friend is sad about something, you are more likely to offer emotional support than suggest ways to deal with the problem.",	"F"],
            ["text"=>"You think that everyone’s views should be respected regardless of whether they are supported by facts or not.",	"F"],
            ["text"=>"You believe that it is more rewarding to be liked by others than to be powerful",	"F"],
            ["text"=>"Winning a debate matters less to you than making sure no one gets upset.",	"F"],
            ["text"=>"You are usually highly motivated and energetic.",	"E"],
            ["text"=>"You do not mind being at the center of attention.",	"E"],
            ["text"=>"It does not take you much time to start getting involved in social activities at your new workplace.",	"E"],
            ["text"=>"You feel more energetic after spending time with a group of people.",	"E"],
            ["text"=>"You worry too much about what other people think",	"E"],
            ["text"=>"You often take initiative in social situations",	"E"],
            ["text"=>"You often feel as if you have to justify yourself to other people.",	"E"],
            ["text"=>"You do not let other people influence your actions.",	"A"],
            ["text"=>"Your emotions control you more than you control them",	"A"],
            ["text"=>"You see yourself as very emotionally stable.",	"A"],
            ["text"=>"You find it easy to stay relaxed and focused even when there is some pressure.","A"],
        ];
    }
}
