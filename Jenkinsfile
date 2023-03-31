@Library('utils@master') _
import com.lmig.intl.cloud.jenkins.util.EnvConfigUtil

countryParams = new EnvConfigUtil().getCountryEnvDetails(env.JOB_NAME)
def customWorkerImages = ['php=container-images.lmig.com/docker/o7820428/drupal9_php8:0.9.8']

pipeline {
    agent {
        kubernetes {
            yaml pod(mode:'Declarative', workers:customWorkerImages)
        }
    }

    environment {
        appEnv = "${countryParams.countryEnv}"
        appCountry = "${countryParams.countryCode}"
        zipFileName = "function.zip"
        exclude = "-x '*.git*' README.md composer.lock prod_Jenkinsfile app.json .editorconfig Jenkinsfile"
        appName = ""
    }

    stages {

        stage("Read app.json") {
            steps {
                script {
                    props = readJSON file: 'app.json'
                    appName =  props.appName
                    deployJob = props.deployJob
                    trouxuid = props.trouxuid

                    echo "appName.................: ${appName}"
                    echo "deployJob...............: ${props.deployJob}"
                    echo "trouxuid................: ${props.trouxuid}"
                }
            }
        }

        
        stage("Compose Install") {
            steps {
                container("php") {
                    sh 'composer install'
                    sh 'ls -lh'
		    sh 'ls -lh docroot/modules/contrib/webform/includes'
                }
            }
        }

        stage("Sonar") {
            steps {
                script {
				   //copio codigo personalizar a un directorio para ser analizado
				   sh "mkdir sonar"
				   sh "mkdir sonar/docroot"
				   sh "mkdir sonar/docroot/modules"
				   
				   sh "cp docroot/modules/custom sonar/docroot/modules -R"
				   sh "cp docroot/themes/custom sonar/docroot/themes -R"

                   def codeSources = 'sonar'
                   def SonarProjectKey = "${appName}"
                   def packageVersion = '0.0.1'
                   withSonarQubeEnv('sonarqube') {
                        sh "ls -la"
                        echo "sonarSources: ${codeSources}"
                        echo "sonarProjectName: ${appName}"

                        sh "sonar-scanner -Dsonar.projectKey=${SonarProjectKey} -Dsonar.projectName=${appName} -Dsonar.projectVersion=${packageVersion} -Dsonar.sources=${codeSources}"                      
                   }
                   sh "rm sonar -Rf"
                }
            }
        }
        stage('zip Function') {	
            steps{
                script{
                    sh "zip -r ${zipFileName} . ${exclude}"
                }
            }
        }

        stage('artifactory upload dev/nonprod build') {
            when {
                expression {
                    return appEnv == "nonprod";
                }
            }
            steps{
                script{
                    artifacts = [
                        "${zipFileName}",
                        'prod_Jenkinsfile',
                        'app.json'
                    ]
                    //artifactoryUploadFiles files: artifacts, version: CodeVersion
                }
            }
        }

        stage('Call devops job in dev') {
            when {
                expression {
                    return appEnv == "dev";
                }
            }
            steps{
                build job: deployJob, wait: false, parameters: [[$class: 'StringParameterValue', name: 'CommitIdFromDevelopBranch', value: env.GIT_COMMIT]]
            }
        }
    }
}
