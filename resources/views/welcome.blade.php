@extends('layouts.base')

@section('titre', 'Bienvenue')

@section('paragraphe', 'Bienvenue dans la banque de mémoire de ESM-Bénin')
<br>
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-6">
                <h2>Présentation de l'application</h2>
                <p>
                    Les mémoires académiques constituent des documents de recherche originaux, souvent le fruit d'un travail de longue haleine réalisé par les étudiants dans le cadre de leurs cursus universitaires. Ils contribuent à l'avancement des connaissances dans divers domaines en apportant de nouvelles perspectives, des données empiriques et des analyses critiques. La conservation des mémoires permet de préserver le savoir accumulé au fil du temps, offrant ainsi une base solide pour les futures recherches et les références académiques.
                </p>
                <p>
                    La conservation et la diffusion des mémoires académiques représentent des aspects cruciaux de la gestion des connaissances au sein des institutions d'enseignement supérieur. Ce thème englobe un ensemble d'enjeux et de pratiques visant à préserver le patrimoine intellectuel de l'université tout en facilitant l'accès et le partage des connaissances au sein de la communauté académique.
                </p>
                <p>
                    Notre application web est conçue pour faciliter la gestion et la diffusion des mémoires académiques de l'ESM-Bénin. Elle offre une plateforme sécurisée et conviviale pour la consultation, le téléchargement et le stockage des mémoires.
                </p>
                <p>
                    L'application permet aux utilisateurs de rechercher des mémoires en fonction de différents critères tels que le sujet, l'auteur, l'année, etc. Les mémoires sont organisés par catégories ou par domaines d'études pour faciliter la recherche et la navigation. Les utilisateurs peuvent prévisualiser les mémoires avant de les télécharger pour décider de leur pertinence.
                </p>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0"> <!-- Ajout de marges sur les petits écrans pour séparer les colonnes -->
                <div class="alert alert-danger" role="alert">
                    <x-info></x-info>
                </div>
                <h2>Tarif</h2>
                <p>
                    L'accès à notre application est disponible au tarif de 500F, offrant ainsi un accès abordable à une vaste base de connaissances académiques. Ce tarif permet de couvrir les coûts de maintenance et de développement de l'application, tout en garantissant un accès équitable à tous les utilisateurs.
                </p>
                <h2>Nous contacter</h2>
                <p>Pour tout problème, nous restons joignables.</p>
                <p>
                    <a href="https://wa.me/22935529687?text=Bonjour%20ESM_Benin">
                        <i class="fab fa-whatsapp"></i> 22935529687
                    </a>
                </p>
                <p>
                    <a href="mailto:esmbenin@gmail.com?subject=Information%20sur%20l'étudiant&body=Bonjour%20ESMBenin">
                        <i class="fas fa-envelope"></i> esmbenin@gmail.com
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
