@Library('utils@master') _
import com.lmig.intl.cloud.jenkins.util.EnvConfigUtil

def envUtil = null;
def countryParams = null;
def rtMaven = null;
def server = null;
envUtil = new EnvConfigUtil();
def countryParams = envUtil.getCountryEnvDetails(env.JOB_NAME);

pipeline {
    agent { label 'linux' }

    /**
     * Prepare instances for tasks
     */
    stages {
        stage('git Checkout') {
            steps {
                script {
                    checkout scm
                }
            }
        }

        stage('Install dependencies') {
			steps{
				script{
					echo "Install"
						dir('.'){
                            sh 'composer install --optimize-autoloader --no-dev'
                            sh 'ls -lh'
						}	
					}
	        }
		}

       /*stage('zip Function') {	
            steps{
                dir(codeSources) {
                    sh "zip -r ${zipFileName} ${include} ${exclude}"
                }
            }
        }
		
		stage('artifactory upload') {
            steps{
				script{
					echo "Deploy to ${countryParams.countryEnv.toLowerCase()} artifactory"
					artifacts = []
					artifacts.push("${codeSources}/package.json")
					artifacts.push("${codeSources}/${zipFileName}")
					artifacts.push('prod_Jenkinsfile')
					artifacts.push('app.json')
					artifactoryUploadFiles files: artifacts, version: packageVersion
					
					artifactoryUploadFiles files: artifacts, version: "${packageVersion}"

				}
			}
			
        }*/

    } // stages
} // pipeline