<?php

namespace Lmorales\LaravelEntityGenerator\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class MakeEntity extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model Entity';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Entity';

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $entityClass;

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $model;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire(){

        $this->setEntityClass();

        $path = $this->getPath($this->entityClass);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($this->repositoryClass));

        $this->info($this->type.' created successfully.');

        $this->line("<info>Created Repository :</info> $this->repositoryClass");
    }

    /**
     * Set repository class name
     *
     * @return  void
     */
    private function setEntityClass()
    {
        $name = ucwords(strtolower($this->argument('name')));

        $this->model = $name;

        $modelClass = $this->parseName($name);

        $this->repositoryClass = $modelClass . 'Repository';

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if(!$this->argument('name')){
            throw new InvalidArgumentException("Missing required argument model name");
        }

        $stub = parent::replaceClass($stub, $name);

        return str_replace('DummyModel', $this->model, $stub);
    }

    /**
     * 
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // return  base_path('stubs/Repository.stub');
        return __DIR__.'/../../../stubs/entity.stub';
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model class.'],
        ];
    }
}