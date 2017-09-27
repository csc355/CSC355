//BruteForceAndyfinal5.cpp

 

#include <iostream>
#include <string.h>

#include <fstream>
#include <iomanip>

#include <stdio.h>
#include <stdlib.h>

#include <errno.h>

#pragma warning(disable : 4996)

using namespace std;

// This is a hash function written in C to return a unique hash for every keyword input

unsigned int RSHash(const char* str, unsigned int length)
{
	unsigned int b = 378551;
	unsigned int a = 63689;
	unsigned int hash = 0;
	unsigned int i = 0;

	for (i = 0; i < length; ++str, ++i)
	{
		hash = hash * a + (*str);
		a = a * b;
	}
	return hash;
}


int main(int argc, char* argv[])

{
	//   use nested loops to try every unique combination of three successive chars a - z for each member of array trial
	//   to try to match hash of secret codeword (example aaa is first, aab is second, etc)
	
	 char x, y, z
	 
	 
	 
	 INSERT YOUR LOOPS HERE
	 
	 
	 
	 
	 // Print out your latest trial, then use the C/C++ code below to write the keyword
	 // in a file, then read it as a string to input it into RSHash: 
	 
			{
				std::cout << "Trial now is  " << x << y << z << std::endl;

				// Write outfile trail.txt with latest x,y,z               
				ofstream outFile;
				outFile.open("trail.txt");
				outFile << x << y << z << std::endl;
				outFile.close();

				// Now read the outfile in as a C string          
				char code_trial[255];

				FILE *fp = fopen("trail.txt", "r");
				fscanf(fp, "%s", code_trial);
				remove("trail.txt");

				printf("Code_trial is %s \n", code_trial);

				// call RSHash to find out if the keyword hash equals 1876888796
				
				int jRSHash = RSHash(code_trial, 3);
				printf("Hash is  %d \n", jRSHash);

				if (1876888796 == jRSHash)
				{
					std::cout << "Codeword is " << x << y << z << std::endl;
					
		// Correct keyword is found, add code to stop the loop
				}
			}
		}
	}
	 
	return 0;
}

