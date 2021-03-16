<?php
 
namespace App\DataFixtures;
 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
 
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Faker\Factory;
 
 
class AppFixtures extends Fixture
{
   public function load(ObjectManager $manager)
   {
       // $product = new Product();
       // $manager->persist($product);
 
       $this->faker = Factory::create('fr_FR');
 
       // Créer 3 catégories fakée
       for($a = 1;$a <= 3; $a++){
           $category = new Category();
           $category->setTitle($this->faker->sentence())
                    ->setDecription($this->faker->paragraph());
 
           $manager->persist($category);
              // Création entre 4 et 6 articles
              for ($i = 1; $i <= mt_rand(4,6); $i++) {
                $article = new Article();
  
                $content = '<p>'. join($this->faker->paragraphs(5),'</p><p>'.'</p>');
  
  
                $article->setTitle($this->faker->sentence())
                    ->setContent($content)
                    ->setImage($this->faker->imageUrl)
                    ->setCreateAt($this->faker->dateTimeBetween('- 6 months'))
                    ->setCategory($category);
  
                $manager->persist($article);
  
                // Création de commentaires
                for($b = 1; $b <= mt_rand(4, 10); $b++) {
                    $comment = new Comment();
  
                    $content = '<p>' . join($this->faker->paragraphs(2), '</p><p>' . '</p>');
  
                    $days = (new \DateTime())->diff($article->getCreateAt())->days;
  
                    $comment->setAuthor($this->faker->name)
                            ->setContent($content)
                            ->setCreateAt($this->faker->dateTimeBetween('-' . $days . ' days '))
                            ->setArticle($article);
  
                    $manager->persist($comment);
                }
            }       
        }
        $manager->flush();
    }
 }
 
