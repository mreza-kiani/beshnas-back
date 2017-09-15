<?php

use App\Models\Option;
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
        $questions = [
            ["Your mood can change very quickly.", "U"],
            ["You rarely feel insecure.", "U"],
            ["You feel very anxious in stressful situations", "U"],
            ["Your work style is closer to random energy spikes than to a methodical and organized approach.", "U"],
            ["People can rarely upset you.",	"T"],
            ["Logic is usually more important than heart when it comes to making important decisions.",	"T"],
            ["Being right is more important than being cooperative when it comes to teamwork.",	"T"],
            ["It is often difficult for you to relate to other people’s feelings.",	"T"],
            ["In a discussion, truth should be more important than people’s sensitivities.",	"T"],
            ["You rarely do something just out of sheer curiosity.",	"S"],
            ["You consider yourself more practical than creative.",	"S"],
            ["You rarely get carried away by fantasies and ideas.",	"S"],
            ["Your dreams tend to focus on the real world and its events.",	"S"],
            ["You would not call yourself a dreamer.",	"S"],
            ["Generally speaking, you rely more on your experience than your imagination.",	"S"],
            ["You are more of a natural improviser than a careful planner",	"P"],
            ["You would rather improvise than spend time coming up with a detailed plan.",	"P"],
            ["Keeping your options open is more important than having a to-do list.",	"P"],
            ["You often contemplate the reasons for human existence.",	"N"],
            ["You frequently misplace your things.",	"N"],
            ["You often get so lost in thoughts that you ignore or forget your surroundings.",	"N"],
            ["You often find yourself lost in thought when you are walking in nature.",	"N"],
            ["You often spend time exploring unrealistic and impractical yet intriguing ideas.",	"N"],
            ["Your mind is always buzzing with unexplored ideas and plans.",	"N"],
            ["You have always been interested in unconventional and ambiguous things, e.g. in books, art, or movies",	"N"],
            ["Your home and work environments are quite tidy",	"J"],
            ["Your travel plans are usually well thought out.",	"J"],
            ["Being able to develop a plan and stick to it is the most important part of every project.","J"],
            ["You have no difficulties coming up with a personal timetable and sticking to it.",	"J"],
            ["You try to respond to your e-mails as soon as possible and cannot stand a messy inbox.",	"J"],
            ["Being organized is more important to you than being adaptable",	"J"],
            ["You find it difficult to introduce yourself to other people",	"I"],
            ["You do not usually initiate conversations.",	"I"],
            ["You rarely worry about how your actions affect other people.",	"I"],
            ["You are a relatively reserved and quiet person.",	"I"],
            ["You usually find it difficult to relax when talking in front of many people.",	"I"],
            ["If the room is full, you stay closer to the walls, avoiding the center",	"I"],
            ["An interesting book or a video game is often better than a social event.",	"I"],
            ["As a parent, you would rather see your child grow up kind than smart.",	"F"],
            ["If your friend is sad about something, you are more likely to offer emotional support than suggest ways to deal with the problem.",	"F"],
            ["You think that everyone’s views should be respected regardless of whether they are supported by facts or not.",	"F"],
            ["You believe that it is more rewarding to be liked by others than to be powerful",	"F"],
            ["Winning a debate matters less to you than making sure no one gets upset.",	"F"],
            ["You are usually highly motivated and energetic.",	"E"],
            ["You do not mind being at the center of attention.",	"E"],
            ["It does not take you much time to start getting involved in social activities at your new workplace.",	"E"],
            ["You feel more energetic after spending time with a group of people.",	"E"],
            ["You worry too much about what other people think",	"E"],
            ["You often take initiative in social situations",	"E"],
            ["You often feel as if you have to justify yourself to other people.",	"E"],
            ["You do not let other people influence your actions.",	"A"],
            ["Your emotions control you more than you control them",	"A"],
            ["You see yourself as very emotionally stable.",	"A"],
            ["You find it easy to stay relaxed and focused even when there is some pressure.","A"],
        ];
        foreach ($questions as $question){
            $newQ = \App\Models\Question::create([
                "text" => $question[0]
            ]);
            $optionConfig = $this->getQuestionConfig($question[1]);
            $optionConfig["text"] = "Yes";
            $optionConfig["question_id"] = $newQ->id;

            Option::create($optionConfig);

            $optionConfig = $this->getReverseQuestionConfig($optionConfig);
            $optionConfig["text"] = "No";
            Option::create($optionConfig);
        }
    }

    private function getQuestionConfig($option)
    {
        $optionConfig = [];
        if ($option == 'I')
            $optionConfig["mind"] = Option::$personalityTypes["mind"]["introvert"];
        elseif ($option == 'E')
            $optionConfig["mind"] = Option::$personalityTypes["mind"]["extrovert"];
        elseif ($option == "S")
            $optionConfig["energy"] = Option::$personalityTypes["energy"]["observant"];
        elseif ($option == "N")
            $optionConfig["energy"] = Option::$personalityTypes["energy"]["intuitive"];
        elseif ($option == "F")
            $optionConfig["nature"] = Option::$personalityTypes["nature"]["feeling"];
        elseif ($option == "T")
            $optionConfig["nature"] = Option::$personalityTypes["nature"]["thinking"];
        elseif ($option == "J")
            $optionConfig["tactics"] = Option::$personalityTypes["tactics"]["judging"];
        elseif ($option == "P")
            $optionConfig["tactics"] = Option::$personalityTypes["tactics"]["prospecting"];
        elseif ($option == "A")
            $optionConfig["identity"] = Option::$personalityTypes["identity"]["assertive"];
        else
            $optionConfig["identity"] = Option::$personalityTypes["identity"]["turbulent"];
        return $optionConfig;
    }

    private function getReverseQuestionConfig($optionConfig)
    {
        if (array_key_exists('mind', $optionConfig)){
            $optionConfig["mind"] = 3 - $optionConfig["mind"];
        }
        elseif (array_key_exists('energy', $optionConfig)){
            $optionConfig["energy"] = 3 - $optionConfig["energy"];
        }
        elseif (array_key_exists('nature', $optionConfig)){
            $optionConfig["nature"] = 3 - $optionConfig["nature"];
        }
        elseif (array_key_exists('tactics', $optionConfig)) {
            $optionConfig["tactics"] = 3 - $optionConfig["tactics"];
        }
        else{
            $optionConfig["identity"] = 3 - $optionConfig["identity"];
        }
        return $optionConfig;
    }
}
