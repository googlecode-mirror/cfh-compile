PHP applications and frameworks are growing all the time and usually contain dozens of files are being included on each request.

These file operations are as time consuming as sending multiple queries to database server. The clean separation of class per file works well in developing environment, however when project goes commercial distribution the speed overcomes the clean separation of class per file convention.

Compiling is a method for making a single file of these components.

Including the compiled file instead of multiple files can improve performance by an order of magnitude.