<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */
(@include_once __DIR__ . '/../vendor/autoload.php') || @include_once __DIR__ . '/../../../autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use RespectDoctrine\Doctrine\Doctrine;
use Doctrine\DBAL\Migrations\Tools\Console\Command as MigrationsCommand;

Doctrine::setConfigDir("../app/config.php");
Doctrine::setIsDevMode(true);

$doctrine = new Doctrine();
$em = $doctrine->getEntityManager();
$helper = ConsoleRunner::createHelperSet($em);

#Namespace generate migration
chdir(__DIR__.'/../app/migrations');

$commands = array();
$commands[] = new MigrationsCommand\ExecuteCommand();
$commands[] = new MigrationsCommand\GenerateCommand();
$commands[] = new MigrationsCommand\DiffCommand();
$commands[] = new MigrationsCommand\MigrateCommand();
$commands[] = new MigrationsCommand\StatusCommand();
$commands[] = new MigrationsCommand\VersionCommand();


ConsoleRunner::run($helper, $commands);
