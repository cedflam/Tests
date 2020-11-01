<?php


namespace App\Tests\Entity;


use App\Entity\InvitationCode;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class InvitationCodeTest
 * @package App\Tests\Entity
 */
class InvitationCodeTest extends KernelTestCase
{
    /**
     *
     */
    use FixturesTrait;

    /**
     * Permet de créer un objet InvitationCode
     *
     * @return InvitationCode
     */
    public function getEntity(): InvitationCode
    {
        $code = new InvitationCode();
        return $code->setCode('12345')
            ->setDescription('Description de test')
            ->setExpireAt(new \DateTime());
    }

    /**
     * Assertion personnalisée
     *
     * @param InvitationCode $code
     * @param int $number
     */
    public function assertHasError(InvitationCode $code, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($code);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error){
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }
        $this->assertCount($number, $errors, implode( ', ',$messages));
    }

    /**
     * Test la validité de l'entité
     */
    public function testValidEntity()
    {
         $this->assertHasError($this->getEntity(), 0);
    }

    /**
     * Test error code
     */
    public function testInvalidCodeEntity()
    {
        $code = $this->getEntity()->setCode('123a45');
        $this->assertHasError($code, 1);
        $code = $this->getEntity()->setCode('125');
        $this->assertHasError($code, 1);

    }

    /**
     * Test error code blank
     */
    public function testInvalidBlankCodeEntity()
    {
        $code = $this->getEntity()->setCode('');
        $this->assertHasError($code, 1);
    }

    /**
     * Test error description blank
     */
    public function testInvalidBlankDescriptionEntity()
    {
        $code = $this->getEntity()->setDescription('');
        $this->assertHasError($code, 1);
    }

    /**
     * Test si un code est invalide
     */
    public function testInvalidUsedCode()
    {
        $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/invitation_code.yaml']);
        $code = $this->getEntity()->setCode('54321');
        $this->assertHasError($code, 1);
    }
}