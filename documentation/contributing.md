# OC - p8

## Contributing

Here is the process to contribute to ToDo & Co in the right way. 

### The application

ToDo & Co is an application who helps people organize their tasks and give them a look 
of their progression all over their owns tasks. In that sense the app is focused on the user.

If you want to submit some change to the application you may discuss with the team by creating a new issue in the 
repository. Take care of don't create a new issue which might have been already discussed. Instead of that you may 
open again this issue (if it has been closed) and continuing the discussion.

You all are human being, be kind to everbody. Nor harassment nor verbal abuse would be accepted while discussing 
or wherever.

### Structure

This project is a Symfony project, it follows a standard structure :
* config (to handle Symfony bundles)
* src (act like the heart of our app) :
  * Controller (bind repositories to templates)
  * DataFixtures (fictitious data)
  * Entity (handle entities, constraints and links)
  * Form (each form types)
  * Repository (request to DB)
  * Security (authentication and authorization)
* templates (twig files)
* tests (test the app)

### Recommendations

__To make a pull request :__

* __Follow PSR__
* __Follow as much as possible this structure.__
* __Write and run tests to reach at least 70% code coverage__

### Process

1. Create a fork of the project
2. Please follow [README](../readme.md) after step 2 and come back right here
3. Create a new branch on which you will work on following the rules
4. Write and run tests as said before
5. Push the branch on your side
6. Open a pull request on __this__ GitHub project
