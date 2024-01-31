<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager): void
    {
        $lorem = [
            "Pellentesque rutrum nunc vel ligula eleifend, in bibendum dolor gravida.",
            "Suspendisse dignissim nisl at dolor varius ornare.",
            "Nullam dignissim odio ut eros vehicula hendrerit.",
            "Proin eu dolor faucibus, sollicitudin lectus in, placerat nunc.",
            "Praesent eu massa ullamcorper, gravida elit sollicitudin, vehicula massa.",
            "Ut in purus scelerisque, volutpat nisi quis, commodo augue.",
            "Donec vitae diam eget dolor convallis pretium id non justo.",
            "Proin a erat eu est porta finibus eu vel lacus.",
            "Ut in elit a quam eleifend aliquam.",
            "Fusce ornare neque sit amet nunc ultrices, in consequat sem malesuada.",
            "Suspendisse sed massa sollicitudin, interdum nibh eu, pulvinar tortor.",
            "Morbi in lacus et ex lacinia tempus.",
            "Suspendisse rhoncus nisl eu lacus condimentum, ac tempus est pellentesque.",
            "Nunc sit amet felis egestas, blandit velit consectetur, tristique elit.",
            "Sed pharetra enim a ultricies tincidunt.",
            "Suspendisse imperdiet libero ac viverra rhoncus.",
            "Maecenas congue diam eu ligula semper fermentum.",
            "Suspendisse non ante et ipsum dictum faucibus.",
            "Nulla tempor orci eget varius tincidunt.",
            "Pellentesque eget sem egestas, venenatis nibh non, sodales nisl.",
            "Curabitur lobortis lectus quis ullamcorper ultricies.",
            "Donec porttitor augue non justo laoreet, nec sagittis nisl egestas.",
            "Mauris eget mauris eu mauris pretium malesuada et a quam.",
            "Mauris consequat justo sit amet nisi lacinia, vel dictum leo laoreet.",
            "Mauris pretium ex at lectus dictum gravida.",
            "Curabitur sit amet nisl rhoncus, ultrices erat at, interdum neque.",
            "Etiam ultrices ante a libero posuere blandit.",
            "Donec porttitor neque sed blandit sollicitudin.",
            "Pellentesque at lorem vitae magna hendrerit hendrerit.",
            "Curabitur nec ipsum et nulla varius condimentum in sit amet turpis.",
            "Curabitur vehicula tortor vitae odio porttitor, et rutrum mauris facilisis.",
            "Morbi commodo libero quis nibh dictum fermentum.",
            "Quisque id nulla id libero facilisis elementum.",
            "Integer facilisis sem a mi mollis, at elementum lacus scelerisque.",
            "Nulla aliquet nisi viverra, varius ipsum at, porttitor odio.",
            "Donec in velit dictum, fringilla ex sed, gravida nibh.",
            "Duis eget dolor nec eros rutrum scelerisque a nec lectus.",
            "Suspendisse consectetur est pellentesque tortor placerat laoreet.",
            "Sed tristique risus vitae tellus accumsan, et sodales lorem consectetur.",
            "Vivamus luctus nisl eget dui auctor, ut laoreet enim consectetur.",
            "Donec at purus vestibulum, laoreet urna eget, laoreet mauris.",
            "Vestibulum dignissim augue id ultrices pharetra.",
            "Morbi ut nulla dapibus, maximus neque sed, posuere lectus.",
            "Praesent accumsan ex faucibus lacinia ultrices.",
            "Nullam nec leo pellentesque dui interdum tempor.",
            "Vivamus quis ipsum sed arcu porttitor congue vel vitae quam.",
            "Quisque commodo ipsum quis orci aliquet, a sollicitudin metus pulvinar.",
            "Donec vel quam a felis scelerisque semper at id metus.",
            "Vestibulum iaculis quam vel velit scelerisque vulputate.",
            "Morbi cursus justo non neque mollis hendrerit vitae ac turpis.",
            "Nullam porta nulla sed nunc sollicitudin vestibulum ac sit amet mauris.",
            "Donec scelerisque arcu id nibh laoreet, a scelerisque est volutpat.",
            "Phasellus elementum libero et tortor varius, at fringilla erat eleifend.",
            "Cras suscipit metus faucibus, rutrum arcu ut, aliquet libero.",
            "Mauris nec lorem quis augue sollicitudin rhoncus in eget leo.",
            "Proin sit amet elit ultrices, venenatis augue eu, vehicula dolor.",
            "Vivamus porttitor arcu mattis massa pulvinar condimentum.",
            "Cras cursus metus vel nunc suscipit convallis.",
            "Aliquam dictum augue a augue placerat, eu interdum tellus hendrerit.",
            "Nullam posuere leo eu enim pretium, ut dapibus lorem efficitur.",
            "Proin aliquet purus eu dignissim viverra.",
            "Nam ac elit vel leo feugiat convallis nec consequat mi.",
            "Vestibulum non sapien tempor, posuere felis ut, facilisis arcu.",
            "Praesent vestibulum ligula ac tristique placerat.",
            "Maecenas placerat enim eget ante tincidunt, non luctus libero tempus.",
        ];

        for ($element = 0; $element < 50; $element++) {
            $task = new Task();
            $randTitleNb = rand(0, count($lorem) - 1);
            $randContentCount = rand(0, 5);
            $content = "";
            for ($i = 0; $i < $randContentCount; $i++) {
                $randContentNb = rand(0, count($lorem) - 1);
                $content = $content.$lorem[$randContentNb].' ';
            }

            $task->setTitle($lorem[$randTitleNb]);
            $task->setContent($content);
            $task->setIsDone(rand(0, 3) === 0);

            $now = new \DateTimeImmutable("now");
            $randomDuration = rand(0,50);
            $task->setCreatedAt($now->sub(new \DateInterval("P{$randomDuration}D")));

            $author = $this->getReference("user-".rand(0,27));
            $task->setAuthor($author);

            if ($randomDuration > 30) {
                $task->setAuthor(null);
            }

            $manager->persist($task);
        }

        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];

    }


}
