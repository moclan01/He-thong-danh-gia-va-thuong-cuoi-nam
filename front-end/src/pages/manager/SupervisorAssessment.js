import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import MainLayout from '../MainLayout';
import axiosInstance from '../../services/axiosInstance';

function ManagerEvaluateSupervisor() {
    const user = JSON.parse(localStorage.getItem('user'));
    const role = user?.role;
    const { code } = useParams();
    const [evaluationCycles, setEvaluationCycles] = useState([]);
    const [selectedCycle, setSelectedCycle] = useState('');
    const [criteriaForm, setCriteriaForm] = useState(null);
    const [criterias, setCriterias] = useState([]);
    const [questions, setQuestions] = useState([]);
    const [scores, setScores] = useState({}); 
    const [comments, setComments] = useState({}); 
    const [evaluationAnswerId, setEvaluationAnswerId] = useState(null);
    const [answerDetails, setAnswerDetails] = useState([]);
    const [supervisorScores, setSupervisorScores] = useState({}); 
    const [supervisorComments, setSupervisorComments] = useState({}); 
    const [managerScores, setManagerScores] = useState({}); 
    
}